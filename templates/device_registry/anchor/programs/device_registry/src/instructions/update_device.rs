use anchor_lang::prelude::*;
use crate::state::Device;
use crate::errors::DeviceRegistryError;

#[derive(Accounts)]
pub struct UpdateDevice<'info> {
    #[account(mut)]
    pub user: Signer<'info>,

    #[account(
        mut,
        has_one = owner,
        seeds = [
            b"device",
            user.key().as_ref(),
            device.device_id.as_bytes()
        ],
        bump
    )]
    pub device: Account<'info, Device>,
}

pub fn update_device(
    ctx: Context<UpdateDevice>,
    metadata_uri: String,
) -> Result<()> {
    let device = &mut ctx.accounts.device;

    require!(device.is_active, DeviceRegistryError::DeviceAlreadyDeactivated);

    device.metadata_uri = metadata_uri;
    Ok(())
}