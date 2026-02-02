# Solana Escrow Program (Anchor)

This project is a **production-ready Solana escrow smart contract** generated using the Solana Program Builder.

It allows a user to lock SOL in a secure on-chain vault and release or cancel the escrow based on predefined rules.

---

## ✨ Features

- Secure SOL escrow using PDA vaults
- Authority-based release and cancellation
- Clean Anchor-based program structure
- No custodial control by any platform
- Open-source and auditable

---

## 📦 Program Overview

### Instructions

#### `initialize_escrow`
Creates a new escrow and transfers SOL into the escrow vault.

**Parameters**
- `amount` — Amount of SOL (in lamports) to lock

**Accounts**
- `initializer` (signer)
- `escrow` (state account)
- `vault` (PDA vault)
- `system_program`

---

#### `release_escrow`
Releases the escrowed SOL back to the initializer.

**Accounts**
- `escrow`
- `initializer` (signer)
- `vault`

---

#### `cancel_escrow`
Cancels the escrow and returns the locked SOL.

**Accounts**
- `escrow`
- `initializer` (signer)
- `vault`

---

## 🏗 Project Structure

ecrow/ ├── programs/escrow/src/lib.rs ├── Anchor.toml ├── Cargo.toml ├── tests/ └── README.md

--- ## 🚀 Deployment Guide ### 1. Install dependencies ```bash sh -c "$(curl -sSfL ttps://release.solana.com/stable/install)" cargo install --git https://github.com/coral-xyz/anchor anchor-cli 

2. Configure Solana

solana config set --url devnet 

3. Build & deploy

anchor build
anchor deploy 


🧑‍💻 Frontend Usage (JavaScript)

import { Program } from "@coral-xyz/anchor";

const program = new Program(idl, programId, provider);

await program.methods
  .initializeEscrow(new BN(amount))
  .accounts({
    initializer: wallet.publicKey,
    escrow,
    vault,
    systemProgram: SystemProgram.programId,
  })
  .rpc();
  
  
🔐 Security Notes

Funds are held in program-controlled accounts

Only the initializer can release or cancel escrow

All logic executes on-chain

The generator platform does not control any keys


🌍 Decentralization & Open Source

This program:

Runs fully on the Solana blockchain

Can be deployed by anyone

Has no centralized dependencies

Is suitable for public auditing and extension

📄 License

MIT
