// SPDX-License-Identifier: MIT

pragma solidity ^0.8.0;

import "@openzeppelin/contracts/token/ERC20/ERC20.sol";
import "@openzeppelin/contracts/access/Ownable.sol";
import "@openzeppelin/contracts/security/Pausable.sol";

contract SDT is ERC20, Ownable, Pausable {

    constructor(
        string memory name,
        string memory symbol,
        uint256 initialSupply,
        address holder
    ) ERC20(name, symbol) {
        _mint(holder, initialSupply);
    }

    function decimals() public pure override returns (uint8) {
        return 8;
    }

    function totalSupply() public view override returns (uint256) {
        if (paused())
            return 0;
        return super.totalSupply();
    }

    function balanceOf(address account) public view override returns (uint256) {
        if (paused())
            return 0;
        return super.balanceOf(account);
    }

    function _beforeTokenTransfer(address from, address to, uint256 amount) internal override {
        super._beforeTokenTransfer(from, to, amount);
        require(!paused(), "ERC20Pausable: token transfer while paused");
    }

    function pause() external onlyOwner {
        super._pause();
    }

    function unpause() external onlyOwner {
        super._unpause();
    }
}
