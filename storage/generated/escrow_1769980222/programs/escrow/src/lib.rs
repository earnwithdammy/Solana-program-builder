use anchor_lang::prelude::*;
use anchor_lang::system_program;

declare_id!("11111111111111111111111111111111");

#[program]
pub mod escrow {
    use super::*;

    pub fn initialize_escrow(
        ctx: Context<InitializeEscrow>,
        amount: u64,
    ) -> Result<()> {
        let escrow = &mut ctx.accounts.escrow;

        escrow.initializer = ctx.accounts.initializer.key();
        escrow.amount = amount;
        escrow.is_active = true;

        // Transfer SOL from initializer to vault
        let ix = anchor_lang::solana_program::system_instruction::transfer(
            &ctx.accounts.initializer.key(),
            &ctx.accounts.vault.key(),
            amount,
        );

        anchor_lang::solana_program::program::invoke(
            &ix,
            &[
                ctx.accounts.initializer.to_account_info(),
                ctx.accounts.vault.to_account_info(),
            ],
        )?;

        Ok(())
    }

    pub fn cancel_escrow(ctx: Context<CancelEscrow>) -> Result<()> {
        let escrow = &mut ctx.accounts.escrow;
        require!(escrow.is_active, EscrowError::InactiveEscrow);

        escrow.is_active = false;

        Ok(())
    }
}

#[derive(Accounts)]
pub struct InitializeEscrow<'info> {
    #[account(mut)]
    pub initializer: Signer<'info>,

    #[account(
        init,
        payer = initializer,
        space = 8 + 32 + 8 + 1
    )]
    pub escrow: Account<'info, Escrow>,

    /// CHECK: Vault only holds SOL
    #[account(mut)]
    pub vault: UncheckedAccount<'info>,

    pub system_program: Program<'info, System>,
}

#[derive(Accounts)]
pub struct CancelEscrow<'info> {
    #[account(mut)]
    pub initializer: Signer<'info>,

    #[account(mut)]
    pub escrow: Account<'info, Escrow>,
}

#[account]
pub struct Escrow {
    pub initializer: Pubkey,
    pub amount: u64,
    pub is_active: bool,
}

#[error_code]
pub enum EscrowError {
    #[msg("Escrow is not active")]
    InactiveEscrow,
}