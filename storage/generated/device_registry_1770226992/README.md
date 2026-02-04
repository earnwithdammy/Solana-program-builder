# Device Registry Program

On-chain device registry for DePIN protocols.

## Instructions
- register_device(device_id, metadata_uri)
- update_device(metadata_uri)
- deactivate_device()

## PDA
Device:
- seeds: ["device", owner, device_id]

## Use cases
- IoT networks
- DePIN rewards
- Proof-of-location
- Hardware identity

## Frontend
Use Anchor IDL with @coral-xyz/anchor