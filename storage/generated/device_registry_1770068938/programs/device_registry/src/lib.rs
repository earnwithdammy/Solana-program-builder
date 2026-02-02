use anchor_lang::prelude::*;

pub mod errors;
pub mod instructions;
pub mod state;

use instructions::*;

declare_id!("{{PROGRAM_ID}}");

#[program]
pub mod device_registry {
    use super::*;

    pub fn initialize(ctx: Context<Initialize>) -> Result<()> {
        instructions::initialize(ctx)
    }

    pub fn register_device(
        ctx: Context<RegisterDevice>,
        device_id: String,
        metadata_uri: String,
    ) -> Result<()> {
        instructions::register_device(ctx, device_id, metadata_uri)
    }

    pub fn update_device(
        ctx: Context<UpdateDevice>,
        metadata_uri: String,
    ) -> Result<()> {
        instructions::update_device(ctx, metadata_uri)
    }

    pub fn deactivate_device(ctx: Context<DeactivateDevice>) -> Result<()> {
        instructions::deactivate_device(ctx)
    }
}