##

Add feature parity for handling GIF files

Deployment

Seperate GIF instance handling traffic for .gif requests, configured using Skipper, this is to prevent performance degredation against existing requests to other image types.