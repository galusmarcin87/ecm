const Factory = artifacts.require("SDTFactory");
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

contract("Factory", (accounts) => {
    const owner = accounts[0];
    const tokenHolder = accounts[1];
    const tokenName = config.token.name;
    const tokenSymbol = config.token.symbol;

    let factory;

    beforeEach(async function () {
        factory = await Factory.new();
    });

    it("should get owner", async () => {
        const ownerAccount = await factory.owner();

        ownerAccount.should.be.equal(owner);
    });

    it("should transfer ownership", async () => {
        const targetAccount = accounts[1];

        await factory.transferOwnership(targetAccount);
        const ownerAccount = await factory.owner();

        ownerAccount.should.be.equal(targetAccount);
    });

    it("should fail if not-owner wants to transfer ownership", async () => {
        await expectRevert(
            factory.transferOwnership(accounts[1], {from: accounts[4]}),
            "Ownable: caller is not the owner"
        );
    });

    it("should get tokens", async () => {
        const tokens = await factory.getTokens();

        tokens.length.should.be.equal(0);
    });

    it("should create token", async () => {
        await factory.createToken(
            tokenName, tokenSymbol, initialSupplyInTokenUnits, tokenHolder);

        const tokens = await factory.getTokens();
        const token = await Token.at(tokens[0]);
        const tokenOwner = await token.owner();
        const actualTokenName = await token.name();
        const actualTokenSymbol = await token.symbol();
        const balanceOfHolder = await token.balanceOf(tokenHolder);

        tokens.length.should.be.equal(1);
        tokenOwner.should.be.equal(owner);
        actualTokenName.should.be.equal(tokenName);
        actualTokenSymbol.should.be.equal(tokenSymbol);
        balanceOfHolder.should.be.bignumber.equal(initialSupplyInTokenUnits);
    });

    it("should create multiple tokens", async () => {
        await factory.createToken(
            tokenName, tokenSymbol, initialSupplyInTokenUnits, tokenHolder);

        await factory.createToken(
            tokenName, tokenSymbol, initialSupplyInTokenUnits, tokenHolder);

        await factory.createToken(
            tokenName, tokenSymbol, initialSupplyInTokenUnits, tokenHolder);

        const tokens = await factory.getTokens();

        tokens.length.should.be.equal(3);
    });

    it("should emit Deployed event", async () => {
        expectEvent(
            await factory.createToken(
                tokenName, tokenSymbol, initialSupplyInTokenUnits, tokenHolder),
            "Deployed",
            {
                name: tokenName,
                symbol: tokenSymbol,
                initialSupply: initialSupplyInTokenUnits,
                holder: tokenHolder
            },
        );
    });

    it("should fail if not-owner wants to create token", async () => {
        await expectRevert(
            factory.createToken(
                tokenName, tokenSymbol, initialSupplyInTokenUnits, tokenHolder,
                {from: accounts[4]}),
            "Ownable: caller is not the owner"
        );
    });
});
