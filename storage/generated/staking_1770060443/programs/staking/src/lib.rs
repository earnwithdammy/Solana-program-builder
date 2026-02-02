use anchor_lang::prelude::*;

pub mod errors;
pub mod instructions;
pub mod state;

use instructions::*;

declare_id!("{{PROGRAM_ID}}");

#[program]
pub mod staking {
    use super::*;

    pub fn initialize(ctx: Context<Initialize>) -> Result<()> {
        instructions::initialize(ctx)
    }

    pub fn stake(
        ctx: Context<Stake>,
        amount: u64,
        lock_period: i64,
    ) -> Result<()> {
        instructions::stake(ctx, amount, lock_period)
    }

    pub fn unstake(ctx: Context<Unstake>) -> Result<()> {
        instructions::unstake(ctx)
    }
}