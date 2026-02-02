use anchor_lang::prelude::*;

declare_id!("DePin11111111111111111111111111111111");

#[program]
pub mod device_registry {
    use super::*;

    pub fn register_device(
        ctx: Context<RegisterDevice>,
        device_id: String,
        metadata_uri: String
    ) -> Result<()> {
        let device = &mut ctx.accounts.device;

        device.owner = ctx.accounts.user.key();
        device.device_id = device_id;
        device.metadata_uri = metadata_uri;
        device.active = true;

        Ok(())
    }

    pub fn deactivate_device(ctx: Context<DeactivateDevice>) -> Result<()> {
        let device = &mut ctx.accounts.device;
        device.active = false;
        Ok(())
    }
}

#[account]
pub struct Device {
    pub owner: Pubkey,
    pub device_id: String,
    pub metadata_uri: String,
    pub active: bool,
}

#[derive(Accounts)]
pub struct RegisterDevice<'info> {
    #[account(
        init,
        payer = user,
        space = 8 + 32 + 64 + 128 + 1,
        seeds = [b"device", user.key().as_ref()],
        bump
    )]
    pub device: Account<'info, Device>,
    #[account(mut)]
    pub user: Signer<'info>,
    pub system_program: Program<'info, System>,
}

#[derive(Accounts)]
pub struct DeactivateDevice<'info> {
    #[account(mut, has_one = owner)]
    pub device: Account<'info, Device>,
    pub owner: Signer<'info>,
}