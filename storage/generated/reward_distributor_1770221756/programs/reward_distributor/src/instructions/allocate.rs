use anchor_lang::prelude::*;
use crate::state::{RewardPool, ClaimStatus};

#[derive(Accounts)]
pub struct Allocate<'info> {
    #[account(has_one = authority)]
    pub pool: Account<'info, RewardPool>,

    pub authority: Signer<'info>,

    #[account(
        init,
        payer = authority,
        space = 8 + 32 + 8 + 1,
        seeds = [b"claim", user.key().as_ref()],
        bump
    )]
    pub claim_status: Account<'info, ClaimStatus>,

    /// CHECK: user receiving reward
    pub user: UncheckedAccount<'info>,

    pub system_program: Program<'info, System>,
}

pub fn handler(ctx: Context<Allocate>, amount: u64) -> Result<()> {
    let claim = &mut ctx.accounts.claim_status;
    claim.user = ctx.accounts.user.key();
    claim.amount = amount;
    claim.claimed = false;
    Ok(())
}