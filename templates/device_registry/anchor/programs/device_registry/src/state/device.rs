use anchor_lang::prelude::*;

#[account]
pub struct Device {
    pub owner: Pubkey,
    pub device_id: String,
    pub metadata_uri: String,
    pub registered_at: i64,
    pub is_active: bool,
}

impl Device {
    pub const MAX_DEVICE_ID_LEN: usize = 64;
    pub const MAX_URI_LEN: usize = 200;

    pub const LEN: usize = 8  // discriminator
        + 32                 // owner
        + 4 + Self::MAX_DEVICE_ID_LEN
        + 4 + Self::MAX_URI_LEN
        + 8                  // registered_at
        + 1;                 // is_active
}