const Token = artifacts.require("SDT");
const Crowdsale = artifacts.require("ReversedRateCrowdsale");

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

contract.skip("TokenCrowdsale", (accounts) => {
    const tokenHolder = accounts[1];
    const crowdsaleOwner = accounts[0];
    const crowdsaleRate = new BN(config.crowdsale.rate);
    const crowdsaleWallet = accounts[8];

    let token;
    let crowdsale;

    beforeEach(async function () {
        token = await Token.new(
            config.token.name, config.token.symbol, initialSupplyInTokenUnits, tokenHolder);
        crowdsale = await Crowdsale.new(token.address, crowdsaleRate, crowdsaleWallet);
    });

    it("should get owner", async () => {
        const ownerAccount = await crowdsale.owner();

        ownerAccount.should.be.equal(crowdsaleOwner);
    });

    it("should transfer ownership", async () => {
        const targetAccount = accounts[2];

        await crowdsale.transferOwnership(targetAccount);
        const ownerAccount = await crowdsale.owner();

        ownerAccount.should.be.equal(targetAccount);
    });

    it("should fail if not-owner wants to transfer ownership", async () => {
        await expectRevert(
            crowdsale.transferOwnership(accounts[2], {from: accounts[4]}),
            "Ownable: caller is not the owner"
        );
    });

    it("should get token", async () => {
        const tokenAddress = await crowdsale.token();

        tokenAddress.should.be.equal(token.address);
    });

    it("should get rate", async () => {
        const rate = await crowdsale.rate();

        rate.should.be.bignumber.equal(crowdsaleRate);
    });

    it("should get wallet", async () => {
        const walletAccount = await crowdsale.wallet();

        walletAccount.should.be.equal(crowdsaleWallet);
    });

    it("should set wallet", async () => {
        const targetAccount = accounts[2];

        await crowdsale.setWallet(targetAccount);
        const walletAccount = await crowdsale.wallet();

        walletAccount.should.be.equal(targetAccount);
    });

    it("should fail if new wallet is the zero address", async () => {
        await expectRevert(
            crowdsale.setWallet(constants.ZERO_ADDRESS),
            "Crowdsale: wallet is the zero address"
        );
    });

    it("should fail if not-owner wants to set wallet", async () => {
        await expectRevert(
            crowdsale.setWallet(accounts[2], {from: accounts[4]}),
            "Ownable: caller is not the owner"
        );
    });

    it("should transfer tokens to crowdsale", async () => {
        const amount = new BN("123000000");

        await token.transfer(crowdsale.address, amount, {from: tokenHolder});
        const balance = await token.balanceOf(crowdsale.address);

        balance.should.be.bignumber.equal(amount);
    });

    it("should sell tokens and transfer to buyer", async () => {
        const buyer = accounts[3];
        const wei = new BN("987000000000000000");
        const amount = wei.div(crowdsaleRate);

        await token.transfer(crowdsale.address, amount, {from: tokenHolder});
        const balanceOfBuyerBefore = await token.balanceOf(buyer);
        await crowdsale.buyTokens(buyer, {from: buyer, value: wei});
        const balanceOfBuyerAfter = await token.balanceOf(buyer);

        balanceOfBuyerAfter.should.be.bignumber.equal(balanceOfBuyerBefore.add(amount));
    });

    it("should sell tokens via fallback and transfer to buyer", async () => {
        const buyer = accounts[3];
        const wei = new BN("987000000000000000");
        const amount = wei.div(crowdsaleRate);

        await token.transfer(crowdsale.address, amount, {from: tokenHolder});
        const balanceOfBuyerBefore = await token.balanceOf(buyer);
        await web3.eth.sendTransaction({from: buyer, to: crowdsale.address, value: wei, gas: "1140000"});
        const balanceOfBuyerAfter = await token.balanceOf(buyer);

        balanceOfBuyerAfter.should.be.bignumber.equal(balanceOfBuyerBefore.add(amount));
    });

    it("should sell tokens and transfer ether to wallet", async () => {
        const buyer = accounts[3];
        const wei = new BN("8760000000000000000");
        const amount = wei.div(crowdsaleRate);

        await token.transfer(crowdsale.address, amount, {from: tokenHolder});
        const balanceOfWalletBefore = await balance.current(crowdsaleWallet);
        await crowdsale.buyTokens(buyer, {from: buyer, value: wei});
        const balanceOfWalletAfter = await balance.current(crowdsaleWallet);

        balanceOfWalletAfter.should.be.bignumber.equal(balanceOfWalletBefore.add(wei));
    });

    it("should sell tokens and transfer ether to new wallet", async () => {
        const buyer = accounts[3];
        const wei = new BN("123000000000000000");
        const amount = wei.div(crowdsaleRate);
        const newWallet = accounts[7];

        await token.transfer(crowdsale.address, amount, {from: tokenHolder});
        await crowdsale.setWallet(newWallet);
        const balanceOfWalletBefore = await balance.current(newWallet);
        await crowdsale.buyTokens(buyer, {from: buyer, value: wei});
        const balanceOfWalletAfter = await balance.current(newWallet);

        balanceOfWalletAfter.should.be.bignumber.equal(balanceOfWalletBefore.add(wei));
    });

    it("should fail if not enough tokens to sell", async () => {
        const buyer = accounts[3];
        const wei = new BN("123000000000000000");
        const amount = wei.div(crowdsaleRate).subn(1);

        await expectRevert(
            crowdsale.buyTokens(buyer, {from: buyer, value: wei}),
            "ERC20: transfer amount exceeds balance"
        );

        await token.transfer(crowdsale.address, amount, {from: tokenHolder});

        await expectRevert(
            crowdsale.buyTokens(buyer, {from: buyer, value: wei}),
            "ERC20: transfer amount exceeds balance"
        );
    });

    it("should fail if beneficiary is the zero address", async () => {
        const buyer = accounts[3];
        const wei = new BN("123000000000000000");
        const amount = wei.div(crowdsaleRate);

        await token.transfer(crowdsale.address, amount, {from: tokenHolder});

        await expectRevert(
            crowdsale.buyTokens(constants.ZERO_ADDRESS, {from: buyer, value: wei}),
            "Crowdsale: beneficiary is the zero address"
        );
    });

    it("should fail if buyer sends no ether", async () => {
        const buyer = accounts[3];
        const wei = 0;

        await expectRevert(
            crowdsale.buyTokens(buyer, {from: buyer, value: wei}),
            "Crowdsale: weiAmount is 0"
        );

        await expectRevert(
            web3.eth.sendTransaction({from: buyer, to: crowdsale.address, value: wei, gas: "1140000"}),
            "Crowdsale: weiAmount is 0"
        );
    });
});
