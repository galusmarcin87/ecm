const web3 = require("web3");
const config = require("./truffle-config");

function toBN(number) {
    return new web3.utils.BN(number);
}

module.exports.toTokenUnits = (tokenAmount) => {
    return toBN(tokenAmount).mul(toBN(10).pow(toBN(config.token.decimals)));
};

module.exports.initialSupplyInTokenUnits = module.exports.toTokenUnits(config.token.initialSupply);
