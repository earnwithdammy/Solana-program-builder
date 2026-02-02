use anchor_lang::prelude::*;

declare_id!("Stake111111111111111111111111111111111");

#[program]
pub mod staking {
    use super::*;

    pub fn initialize(ctx: Context<Initialize>) -> Result<()> {
        let pool = &mut ctx.accounts.pool;
        pool.total_staked = 0;
        Ok(())
    }

    pub fn stake(ctx: Context<Stake>, amount: u64) -> Result<()> {
        let user = &mut ctx.accounts.user_stake;
        let pool = &mut ctx.accounts.pool;

        user.amount += amount;
        pool.total_staked += amount;

        Ok(())
    }

    pub fn unstake(ctx: Context<Unstake>, amount: u64) -> Result<()> {
        let user = &mut ctx.accounts.user_stake;
        let pool = &mut ctx.accounts.pool;

        require!(user.amount >= amount, ErrorCode::InsufficientStake);

        user.amount -= amount;
        pool.total_staked -= amount;

        Ok(())
    }
}

#[account]
pub struct Pool {
    pub total_staked: u64,
}

#[account]
pub struct UserStake {
    pub owner: Pubkey,
    pub amount: u64,
}

#[derive(Accounts)]
pub struct Initialize<'info> {
    #[account(init, payer = user, space = 8 + 8)]
    pub pool: Account<'info, Pool>,
    #[account(mut)]
    pub user: Signer<'info>,
    pub system_program: Program<'info, System>,
}

#[derive(Accounts)]
pub struct Stake<'info> {
    #[account(mut)]
    pub pool: Account<'info, Pool>,
    #[account(
        init_if_needed,
        payer = user,
        space = 8 + 32 + 8,
        seeds = [b"user-stake", user.key().as_ref()],
        bump
    )]
    pub user_stake: Account<'info, UserStake>,
    #[account(mut)]
    pub user: Signer<'info>,
    pub system_program: Program<'info, System>,
}

#[derive(Accounts)]
pub struct Unstake<'info> {
    #[account(mut)]
    pub pool: Account<'info, Pool>,
    #[account(mut)]
    pub user_stake: Account<'info, UserStake>,
}

#[error_code]
pub enum ErrorCode {
    #[msg("Insufficient staked balance")]
    InsufficientStake,
}