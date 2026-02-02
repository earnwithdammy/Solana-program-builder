use anchor_lang::prelude::*;

#[account]
pub struct RewardPool {
    pub authority: Pubkey,
    pub mint: Pubkey,
    pub vault: Pubkey,
    pub bump: u8,
}