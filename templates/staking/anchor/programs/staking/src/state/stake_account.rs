use anchor_lang::prelude::*;

#[account]
pub struct StakeAccount {
    pub owner: Pubkey,
    pub amount: u64,
    pub staked_at: i64,
    pub lock_period: i64,
}

impl StakeAccount {
    pub const LEN: usize = 8 + 32 + 8 + 8 + 8;
}