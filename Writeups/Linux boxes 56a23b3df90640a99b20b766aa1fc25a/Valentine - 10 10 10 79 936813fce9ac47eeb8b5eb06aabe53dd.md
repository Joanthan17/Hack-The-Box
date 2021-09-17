# Valentine - 10.10.10.79

Created: May 8, 2021 10:18 AM

nmap:

dir found:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled.png)

notes.txt:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%201.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%201.png)

encoded key found:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%202.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%202.png)

hex decode it:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%203.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%203.png)

thats the ssh key for hype user. 

we get the password from hearbleed vuln:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%204.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%204.png)

history looks sus:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%205.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%205.png)

socket found:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%206.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%206.png)

with history command we can use the use of tmux  to connect to the socket. by using it we get root:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%207.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%207.png)

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%208.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%208.png)

linpeas got similar lead:

![Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%209.png](Valentine%20-%2010%2010%2010%2079%20936813fce9ac47eeb8b5eb06aabe53dd/Untitled%209.png)