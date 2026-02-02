import * as anchor from "@coral-xyz/anchor";
import { Program } from "@coral-xyz/anchor";
import {
  TOKEN_PROGRAM_ID,
  createMint,
  getOrCreateAssociatedTokenAccount,
  mintTo,
} from "@solana/spl-token";
import { RewardDistributor } from "../target/types/reward_distributor";
import { assert } from "chai";

describe("reward_distributor", () => {
  const provider = anchor.AnchorProvider.env();
  anchor.setProvider(provider);

  const program = anchor.workspace
    .RewardDistributor as Program<RewardDistributor>;

  const authority = provider.wallet;
  const user = anchor.web3.Keypair.generate();

  let mint: anchor.web3.PublicKey;
  let poolPda: anchor.web3.PublicKey;
  let vault: anchor.web3.PublicKey;
  let claimPda: anchor.web3.PublicKey;

  before(async () => {
    // Airdrop to user
    const sig = await provider.connection.requestAirdrop(
      user.publicKey,
      2 * anchor.web3.LAMPORTS_PER_SOL
    );
    await provider.connection.confirmTransaction(sig);

    // Create reward mint
    mint = await createMint(
      provider.connection,
      authority.payer,
      authority.publicKey,
      null,
      6
    );

    // Derive pool PDA
    [poolPda] = anchor.web3.PublicKey.findProgramAddressSync(
      [Buffer.from("reward_pool")],
      program.programId
    );
  });

  it("Initialize reward pool", async () => {
    const vaultAta = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      authority.payer,
      mint,
      poolPda,
      true
    );
    vault = vaultAta.address;

    await program.methods
      .initializePool()
      .accounts({
        pool: poolPda,
        authority: authority.publicKey,
        mint,
        vault,
        systemProgram: anchor.web3.SystemProgram.programId,
        tokenProgram: TOKEN_PROGRAM_ID,
        rent: anchor.web3.SYSVAR_RENT_PUBKEY,
      })
      .rpc();

    const pool = await program.account.rewardPool.fetch(poolPda);
    assert.ok(pool.authority.equals(authority.publicKey));
  });

  it("Fund reward pool", async () => {
    const authorityAta = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      authority.payer,
      mint,
      authority.publicKey
    );

    await mintTo(
      provider.connection,
      authority.payer,
      mint,
      authorityAta.address,
      authority.publicKey,
      1_000_000
    );

    await program.methods
      .fundPool(new anchor.BN(500_000))
      .accounts({
        pool: poolPda,
        authority: authority.publicKey,
        from: authorityAta.address,
        vault,
        tokenProgram: TOKEN_PROGRAM_ID,
      })
      .rpc();
  });

  it("Allocate reward to user", async () => {
    [claimPda] = anchor.web3.PublicKey.findProgramAddressSync(
      [Buffer.from("claim"), user.publicKey.toBuffer()],
      program.programId
    );

    await program.methods
      .allocate(new anchor.BN(100_000))
      .accounts({
        pool: poolPda,
        authority: authority.publicKey,
        claimStatus: claimPda,
        user: user.publicKey,
        systemProgram: anchor.web3.SystemProgram.programId,
      })
      .rpc();

    const claim = await program.account.claimStatus.fetch(claimPda);
    assert.equal(claim.claimed, false);
  });

  it("User claims reward", async () => {
    const userAta = await getOrCreateAssociatedTokenAccount(
      provider.connection,
      authority.payer,
      mint,
      user.publicKey
    );

    await program.methods
      .claim()
      .accounts({
        pool: poolPda,
        claimStatus: claimPda,
        user: user.publicKey,
        vault,
        userToken: userAta.address,
        tokenProgram: TOKEN_PROGRAM_ID,
      })
      .signers([user])
      .rpc();

    const claim = await program.account.claimStatus.fetch(claimPda);
    assert.equal(claim.claimed, true);
  });
});