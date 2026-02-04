use anchor_lang::prelude::*;

#[derive(Accounts)]
pub struct Initialize<'info> {
    #[account(mut)]
    pub admin: Signer<'info>,
}

pub fn initialize(_ctx: Context<Initialize>) -> Result<()> {
    Ok(())
}