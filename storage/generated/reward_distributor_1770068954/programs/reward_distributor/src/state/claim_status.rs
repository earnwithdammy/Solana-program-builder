use anchor_lang::prelude::*;

#[account]
pub struct ClaimStatus {
    pub user: Pubkey,
    pub amount: u64,
    pub claimed: bool,
}