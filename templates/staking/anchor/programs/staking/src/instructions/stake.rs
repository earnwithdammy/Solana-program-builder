use anchor_lang::prelude::*;
use crate::state::StakeAccount;
use crate::errors::StakingError;

#[derive(Accounts)]
pub struct Stake<'info> {
    #[account(mut)]
    pub user: Signer<'info>,

    #[account(
        init,
        payer = user,
        space = StakeAccount::LEN,
        seeds = [b"stake", user.key().as_ref()],
        bump
    )]
    pub stake_account: Account<'info, StakeAccount>,

    pub system_program: Program<'info, System>,
}

pub fn stake(
    ctx: Context<Stake>,
    amount: u64,
    lock_period: i64,
) -> Result<()> {
    require!(amount > 0, StakingError::InvalidAmount);

    let stake_account = &mut ctx.accounts.stake_account;
    let clock = Clock::get()?;

    stake_account.owner = ctx.accounts.user.key();
    stake_account.amount = amount;
    stake_account.staked_at = clock.unix_timestamp;
    stake_account.lock_period = lock_period;

    Ok(())
}