use anchor_lang::prelude::*;

#[error_code]
pub enum RewardError {
    #[msg("Reward already claimed")]
    AlreadyClaimed,

    #[msg("Unauthorized")]
    Unauthorized,

    #[msg("Insufficient vault balance")]
    InsufficientVaultBalance,
}