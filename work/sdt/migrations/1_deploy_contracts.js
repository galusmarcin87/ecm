const Factory = artifacts.require("SDTFactory");
const Token = artifacts.require("SDT");
// const Crowdsale = artifacts.require("ReversedRateCrowdsale");

const config = require("../truffle-config");
const {initialSupplyInTokenUnits} = require("../truffle-helpers");

module.exports = async function (deployer) {
    await deployer.deploy(Factory);
    const factory = await Factory.deployed();

    console.log(`   Creating ${config.token.name}`);
    let response = await factory.createToken(
        config.token.name, config.token.symbol, initialSupplyInTokenUnits, config.token.holder);
    console.log(`   > transaction hash:    ${response.tx}`);
    console.log(`   > gas used:            ${response.receipt.gasUsed}\n`);

    console.log(`   Transferring factory ownership to ${config.factory.owner}`);
    response = await factory.transferOwnership(config.factory.owner);
    console.log(`   > transaction hash:    ${response.tx}`);
    console.log(`   > gas used:            ${response.receipt.gasUsed}\n`);

    const tokenAddress = (await factory.getTokens())[0];
    const token = await Token.at(tokenAddress);

    console.log(`   Transferring token ownership to ${config.token.owner}`);
    response = await token.transferOwnership(config.token.owner);
    console.log(`   > transaction hash:    ${response.tx}`);
    console.log(`   > gas used:            ${response.receipt.gasUsed}\n`);

    // const crowdsaleAddress = (await factory.getCrowdsales())[0];
    // const crowdsale = await Crowdsale.at(crowdsaleAddress);
    //
    // console.log(`   Transferring crowdsale ownership to ${config.crowdsale.owner}`);
    // response = await crowdsale.transferOwnership(config.crowdsale.owner);
    // console.log(`   > transaction hash:    ${response.tx}`);
    // console.log(`   > gas used:            ${response.receipt.gasUsed}\n`);
};
