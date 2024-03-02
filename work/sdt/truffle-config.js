const HDWalletProvider = require("@truffle/hdwallet-provider");
const testPrivateKey = "ca97af6981a88e2a1522f8f95ed4039c52f3ccde0420d8aa69bd3aecb7ae22fa"; //0x89ED90D713d32e98EE5b893380F4419DCDfe5C16
const mainPrivateKey = "219bea78f638f70f7ce6b6c8a87bbb3882c1c7694f8d10cdeb9880deb0db8c62"; //0x1421458073D1F5Eab3C7Aa45D3FD195db715c5c7

module.exports = {
    factory: {
        owner: "0xe67bB0c6F824824aA9aEC690d0f12c88261cfc89",
    },
    token: {
        name: "SDT1 LAB ONE",
        symbol: "SDT1",
        decimals: 8,
        initialSupply: 15730000,
        holder: "0x6eD59919246815f4e2a8A7698Bf8E5B057Eec1f3",
        owner: "0x42e9aC53A1d132caCeE0a1DCDb63Ddb72ECa1786",
    },
    crowdsale: {
        // if decimals == 18, how many token units a buyer gets for 1 wei e.g. 100 when 1 ETH == 100 tokens
        // if decimals < 18, how many wei a buyer pays for 1 token unit e.g. 10^(18-decimals-2) when 1 ETH == 100 tokens
        rate: "100000000", // 1 ETH == 100 token
        wallet: "0x6eD59919246815f4e2a8A7698Bf8E5B057Eec1f3",
        // tokenAmount: "10000",
        owner: "0x56E0c5bAEDD824fF8Fb1B321b0e491ca922872B4",
    },
    // Uncommenting the defaults below
    // provides for an easier quick-start with Ganache.
    // You can also follow this format for other networks;
    // see <http://truffleframework.com/docs/advanced/configuration>
    // for more details on how to specify configuration options!
    //
    networks: {
        development: {
            host: "127.0.0.1",
            port: 7545,
            network_id: "*",
        },
        bscTestnet: {
            // https://ankr.com/rpc
            // https://ethereum.stackexchange.com/questions/82688/timeout-error-on-deploying-to-rinkeby-from-truffle-migrate
            provider: () => new HDWalletProvider({
                privateKeys: [testPrivateKey],
                providerOrUrl: "https://rpc.ankr.com/bsc_testnet_chapel",
                pollingInterval: 600000
            }),
            network_id: "97",
            networkCheckTimeout: 600000,
            timeoutBlocks: 200,
            skipDryRun: true
        },
        mumbai: {
            // https://rpc.maticvigil.com
            provider: () => new HDWalletProvider(
                [testPrivateKey], "wss://rpc-mumbai.maticvigil.com/ws/v1/932e19d16ca9c6b947fc0ecf914df800e84d0a6f"),
            network_id: "80001",
            skipDryRun: true
        },
        rinkeby: {
            // https://infura.io
            provider: () => new HDWalletProvider(
                [testPrivateKey], "wss://rinkeby.infura.io/ws/v3/3099f4f026634520a0982ea3e076f26d"),
            network_id: "4",
            skipDryRun: true
        },
        bsc: {
            provider: () => new HDWalletProvider({
                privateKeys: [mainPrivateKey],
                providerOrUrl: "https://rpc.ankr.com/bsc",
                pollingInterval: 600000
            }),
            network_id: "56",
            networkCheckTimeout: 600000,
            timeoutBlocks: 200
        },
        polygon: {
            provider: () => new HDWalletProvider(
                [mainPrivateKey], "wss://rpc-mainnet.maticvigil.com/ws/v1/932e19d16ca9c6b947fc0ecf914df800e84d0a6f"),
            network_id: "137"
        },
        main: {
            provider: () => new HDWalletProvider(
                [mainPrivateKey], "wss://mainnet.infura.io/ws/v3/3099f4f026634520a0982ea3e076f26d"),
            network_id: "1"
        }
    },
    compilers: {
        solc: {
            version: "0.8.19",
            settings: {
                optimizer: {
                    enabled: true,
                    runs: 200
                }
            }
        }
    },
    plugins: [
        "truffle-plugin-verify"
    ],
    api_keys: {
        etherscan: "P9UHZI4RS8C6BV3QC5JNRW22YRZ72W5Q2P",
        bscscan: "Y84GRSUXUMPVCKYDA7BIHAXSKH3Y84M9TS"
    }
};
