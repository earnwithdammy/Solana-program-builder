use anchor_lang::prelude::*;
use crate::state::Device;
use crate::errors::DeviceRegistryError;

#[derive(Accounts)]
pub struct RegisterDevice<'info> {
    #[account(mut)]
    pub user: Signer<'info>,

    #[account(
        init,
        payer = user,
        space = Device::LEN,
        seeds = [
            b"device",
            user.key().as_ref(),
            device_id.as_bytes()
        ],
        bump
    )]
    pub device: Account<'info, Device>,

    pub system_program: Program<'info, System>,
}

pub fn register_device(
    ctx: Context<RegisterDevice>,
    device_id: String,
    metadata_uri: String,
) -> Result<()> {
    require!(
        !device_id.is_empty(),
        DeviceRegistryError::InvalidDeviceId
    );

    let clock = Clock::get()?;
    let device = &mut ctx.accounts.device;

    device.owner = ctx.accounts.user.key();
    device.device_id = device_id;
    device.metadata_uri = metadata_uri;
    device.registered_at = clock.unix_timestamp;
    device.is_active = true;

    Ok(())
}