use anchor_lang::prelude::*;

#[error_code]
pub enum StakingError {
    #[msg("Stake amount must be greater than zero")]
    InvalidAmount,

    #[msg("Stake is still locked")]
    StakeLocked,

    #[msg("Unauthorized")]
    Unauthorized,
}