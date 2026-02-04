use anchor_lang::prelude::*;

#[error_code]
pub enum DeviceRegistryError {
    #[msg("Unauthorized")]
    Unauthorized,

    #[msg("Device already deactivated")]
    DeviceAlreadyDeactivated,

    #[msg("Invalid device ID")]
    InvalidDeviceId,
}