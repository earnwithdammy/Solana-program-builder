use anchor_lang::prelude::*;
use crate::state::StakeAccount;
use crate::errors::StakingError;

#[derive(Accounts)]
pub struct Unstake<'info> {
    #[account(mut)]
    pub user: Signer<'info>,

    #[account(
        mut,
        close = user,
        seeds = [b"stake", user.key().as_ref()],
        bump,
        has_one = owner
    )]
    pub stake_account: Account<'info, StakeAccount>,

    pub system_program: Program<'info, System>,
}

pub fn unstake(ctx: Context<Unstake>) -> Result<()> {
    let stake_account = &ctx.accounts.stake_account;
    let clock = Clock::get()?;

    require!(
        clock.unix_timestamp
            >= stake_account.staked_at + stake_account.lock_period,
        StakingError::StakeLocked
    );

    Ok(())
}