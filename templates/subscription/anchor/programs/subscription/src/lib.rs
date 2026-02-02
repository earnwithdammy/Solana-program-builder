use anchor_lang::prelude::*;

declare_id!("{{PROGRAM_ID}}");

#[program]
pub mod subscription {
    use super::*;

    pub fn initialize(
        ctx: Context<Initialize>,
        price_lamports: u64,
        duration_seconds: i64,
    ) -> Result<()> {
        let config = &mut ctx.accounts.config;
        config.admin = ctx.accounts.admin.key();
        config.price_lamports = price_lamports;
        config.duration_seconds = duration_seconds;
        Ok(())
    }

    pub fn subscribe(ctx: Context<Subscribe>) -> Result<()> {
        let clock = Clock::get()?;
        let now = clock.unix_timestamp;

        let config = &ctx.accounts.config;
        let sub = &mut ctx.accounts.subscription;

        // Transfer SOL
        **ctx.accounts.user.to_account_info().try_borrow_mut_lamports()? -= config.price_lamports;
        **ctx.accounts.admin.to_account_info().try_borrow_mut_lamports()? += config.price_lamports;

        // Extend or start subscription
        if sub.expires_at > now {
            sub.expires_at += config.duration_seconds;
        } else {
            sub.expires_at = now + config.duration_seconds;
        }

        sub.user = ctx.accounts.user.key();
        Ok(())
    }
}

/* ---------------- ACCOUNTS ---------------- */

#[derive(Accounts)]
pub struct Initialize<'info> {
    #[account(init, payer = admin, space = 8 + 48)]
    pub config: Account<'info, SubscriptionConfig>,
    #[account(mut)]
    pub admin: Signer<'info>,
    pub system_program: Program<'info, System>,
}

#[derive(Accounts)]
pub struct Subscribe<'info> {
    #[account(mut)]
    pub user: Signer<'info>,
    #[account(mut)]
    pub admin: SystemAccount<'info>,
    #[account(mut)]
    pub config: Account<'info, SubscriptionConfig>,
    #[account(
        init_if_needed,
        payer = user,
        space = 8 + 48,
        seeds = [b"sub", user.key().as_ref()],
        bump
    )]
    pub subscription: Account<'info, UserSubscription>,
    pub system_program: Program<'info, System>,
}

/* ---------------- DATA ---------------- */

#[account]
pub struct SubscriptionConfig {
    pub admin: Pubkey,
    pub price_lamports: u64,
    pub duration_seconds: i64,
}

#[account]
pub struct UserSubscription {
    pub user: Pubkey,
    pub expires_at: i64,
}