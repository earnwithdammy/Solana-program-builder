# Staking Program

Production-ready staking program built with Anchor.

## Instructions
- initialize
- stake(amount, lock_period)
- unstake

## PDA
StakeAccount:
- seeds: ["stake", user]

## Errors
- InvalidAmount
- StakeLocked
- Unauthorized

## Frontend
Use Anchor IDL with @coral-xyz/anchor