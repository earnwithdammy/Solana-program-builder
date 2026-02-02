use anchor_lang::prelude::*;
use anchor_spl::token::{Mint, Token, TokenAccount};

use crate::state::RewardPool;

#[derive(Accounts)]
pub struct InitializePool<'info> {
    #[account(
        init,
        payer = authority,
        space = 8 + 32 * 3 + 1,
        seeds = [b"reward_pool"],
        bump
    )]
    pub pool: Account<'info, RewardPool>,

    #[account(mut)]
    pub authority: Signer<'info>,

    pub mint: Account<'info, Mint>,

    #[account(
        init,
        payer = authority,
        token::mint = mint,
        token::authority = pool
    )]
    pub vault: Account<'info, TokenAccount>,

    pub system_program: Program<'info, System>,
    pub token_program: Program<'info, Token>,
    pub rent: Sysvar<'info, Rent>,
}

pub fn handler(ctx: Context<InitializePool>) -> Result<()> {
    let pool = &mut ctx.accounts.pool;
    pool.authority = ctx.accounts.authority.key();
    pool.mint = ctx.accounts.mint.key();
    pool.vault = ctx.accounts.vault.key();
    pool.bump = *ctx.bumps.get("pool").unwrap();
    Ok(())
}