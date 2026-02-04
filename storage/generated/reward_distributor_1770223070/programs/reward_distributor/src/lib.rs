use anchor_lang::prelude::*;

pub mod errors;
pub mod instructions;
pub mod state;

use instructions::*;

declare_id!("{{PROGRAM_ID}}");

#[program]
pub mod reward_distributor {
    use super::*;

    pub fn initialize_pool(ctx: Context<InitializePool>) -> Result<()> {
        initialize_pool::handler(ctx)
    }

    pub fn fund_pool(ctx: Context<FundPool>, amount: u64) -> Result<()> {
        fund_pool::handler(ctx, amount)
    }

    pub fn allocate(ctx: Context<Allocate>, amount: u64) -> Result<()> {
        allocate::handler(ctx, amount)
    }

    pub fn claim(ctx: Context<Claim>) -> Result<()> {
        claim::handler(ctx)
    }
}