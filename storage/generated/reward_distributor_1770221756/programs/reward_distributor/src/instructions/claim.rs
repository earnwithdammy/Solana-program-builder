use anchor_lang::prelude::*;
use anchor_spl::token::{self, Transfer, Token, TokenAccount};
use crate::{
    errors::RewardError,
    state::{RewardPool, ClaimStatus},
};

#[derive(Accounts)]
pub struct Claim<'info> {
    #[account(mut)]
    pub pool: Account<'info, RewardPool>,

    #[account(mut, has_one = user)]
    pub claim_status: Account<'info, ClaimStatus>,

    pub user: Signer<'info>,

    #[account(mut, address = pool.vault)]
    pub vault: Account<'info, TokenAccount>,

    #[account(mut)]
    pub user_token: Account<'info, TokenAccount>,

    pub token_program: Program<'info, Token>,
}

pub fn handler(ctx: Context<Claim>) -> Result<()> {
    let claim = &mut ctx.accounts.claim_status;
    require!(!claim.claimed, RewardError::AlreadyClaimed);

    let seeds = &[b"reward_pool", &[ctx.accounts.pool.bump]];
    let signer = &[&seeds[..]];

    token::transfer(
        CpiContext::new_with_signer(
            ctx.accounts.token_program.to_account_info(),
            Transfer {
                from: ctx.accounts.vault.to_account_info(),
                to: ctx.accounts.user_token.to_account_info(),
                authority: ctx.accounts.pool.to_account_info(),
            },
            signer,
        ),
        claim.amount,
    )?;

    claim.claimed = true;
    Ok(())
}