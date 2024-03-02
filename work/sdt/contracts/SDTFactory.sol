// SPDX-License-Identifier: MIT

pragma solidity ^0.8.0;

import "@openzeppelin/contracts/access/Ownable.sol";
import "./SDT.sol";

contract SDTFactory is Context, Ownable {
    address[] private _tokens;

    event Deployed(address token, string name, string symbol, uint256 initialSupply, address holder);

    function getTokens() external view returns (address[] memory) {
        return _tokens;
    }

    function createToken(
        string memory name,
        string memory symbol,
        uint256 initialSupply,
        address holder
    ) external onlyOwner {

        SDT token = new SDT(name, symbol, initialSupply, holder);
        token.transferOwnership(_msgSender());

        address tokenAddress = address(token);
        _tokens.push(tokenAddress);

        emit Deployed(tokenAddress, name, symbol, initialSupply, holder);
    }
}
