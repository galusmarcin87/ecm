const Token = artifacts.require("SDT");

const should = require("chai").should();

const {
    BN,           // Big Number support
    ether,        // Converts a value in Ether to wei
    balance,      // Inspects Ether balance of a specific account
    constants,    // Common constants, like the zero address and largest integers
    expectEvent,  // Assertions for emitted events
    expectRevert, // Assertions for transactions that should fail
} = require("@openzeppelin/test-helpers");

const config = require("../truffle-config");
const {initialSupplyInTokenUnits} = require("../truffle-helpers");

contract("Token", (accounts) => {
    const owner = accounts[0];
    const holder = accounts[1];
    let token;

    beforeEach(async function () {
        token = await Token.new(
            config.token.name, config.token.symbol, initialSupplyInTokenUnits, holder);
    });

    it("should get owner", async () => {
        const ownerAccount = await token.owner();

        ownerAccount.should.be.equal(owner);
    });

    it("should transfer ownership", async () => {
        const targetAccount = accounts[1];

        await token.transferOwnership(targetAccount);
        const ownerAccount = await token.owner();

        ownerAccount.should.be.equal(targetAccount);
    });

    it("should fail if not-owner wants to transfer ownership", async () => {
        await expectRevert(
            token.transferOwnership(accounts[1], {from: accounts[4]}),
            "Ownable: caller is not the owner"
        );
    });

    it("should mint initial supply to holder", async () => {
        const balance = await token.balanceOf(holder);

        balance.should.be.bignumber.equal(initialSupplyInTokenUnits)
    });

    it("should pause token", async () => {
        await token.pause();

        const isPaused = await token.paused();
        const totalSupply = await token.totalSupply();
        const balance = await token.balanceOf(holder);

        isPaused.should.be.equal(true);
        totalSupply.should.be.bignumber.equal("0");
        balance.should.be.bignumber.equal("0");
    });

    it("should unpause token", async () => {
        await token.pause();
        await token.unpause();

        const isPaused = await token.paused();
        const totalSupply = await token.totalSupply();
        const balance = await token.balanceOf(holder);

        isPaused.should.be.equal(false);
        totalSupply.should.be.bignumber.equal(initialSupplyInTokenUnits);
        balance.should.be.bignumber.equal(initialSupplyInTokenUnits);
    });

    it("should fail if not-owner wants to pause", async () => {
        await expectRevert(
            token.pause({from: accounts[4]}),
            "Ownable: caller is not the owner"
        );
    });

    it("should fail if not-owner wants to unpause", async () => {
        await expectRevert(
            token.unpause({from: accounts[4]}),
            "Ownable: caller is not the owner"
        );
    });

    it("should fail if owner wants to pause twice", async () => {
        await token.pause();
        await expectRevert(
            token.pause(),
            "Pausable: paused"
        );
    });

    it("should fail if owner wants to unpause twice", async () => {
        await expectRevert(
            token.unpause(),
            "Pausable: not paused"
        );
    });

    it("should transfer when unpaused", async () => {
        const receiver = accounts[2];
        const amount = new BN("20000000");

        await token.pause();
        await token.unpause();
        await token.transfer(receiver, amount, {from: holder});

        const balanceOfHolder = await token.balanceOf(holder);
        const balanceOfReceiver = await token.balanceOf(receiver);

        balanceOfHolder.should.be.bignumber.equal(initialSupplyInTokenUnits.sub(amount));
        balanceOfReceiver.should.be.bignumber.equal(amount);
    });

    it("should fail if holder wants to transfer when paused", async () => {
        const receiver = accounts[2];
        const amount = new BN("20000000");

        await token.pause();
        await expectRevert(
            token.transfer(receiver, amount, {from: holder}),
            "ERC20Pausable: token transfer while paused"
        );
    });

    it("should fail if sender does not have enough balance", async () => {
        const sender = accounts[1];
        const receiver = accounts[2];
        const amount = new BN("20000000");

        await token.transfer(receiver, amount, {from: sender});
        const balanceOfSender = await token.balanceOf(sender);
        const balanceOfReceiver = await token.balanceOf(receiver);

        await expectRevert(
            token.transfer(receiver, balanceOfSender.addn(1), {from: sender}),
            "ERC20: transfer amount exceeds balance"
        );

        await expectRevert(
            token.transfer(receiver, initialSupplyInTokenUnits.addn(1), {from: sender}),
            "ERC20: transfer amount exceeds balance"
        );

        await expectRevert(
            token.transfer(sender, balanceOfReceiver.addn(1), {from: receiver}),
            "ERC20: transfer amount exceeds balance"
        );

        await expectRevert(
            token.transfer(sender, balanceOfReceiver.add(amount), {from: receiver}),
            "ERC20: transfer amount exceeds balance"
        );

        await expectRevert(
            token.transfer(sender, initialSupplyInTokenUnits.addn(1), {from: receiver}),
            "ERC20: transfer amount exceeds balance"
        );
    });
});
