use anchor_lang::prelude::*;
use crate::state::Device;
use crate::errors::DeviceRegistryError;

#[derive(Accounts)]
pub struct DeactivateDevice<'info> {
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

pub fn deactivate_device(ctx: Context<DeactivateDevice>) -> Result<()> {
    let device = &mut ctx.accounts.device;

    require!(device.is_active, DeviceRegistryError::DeviceAlreadyDeactivated);

    device.is_active = false;
    Ok(())
}