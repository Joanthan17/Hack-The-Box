#!/usr/bin/python3

import string

lowers = string.ascii_lowercase
normal_txt = "Orestis - Hacking for fun and profit".lower()

code1 = "Qbqquzs - Pnhekxs dpi fca fhf zdmgzt".lower()
m1 = "Si rbazmvm, Q'yq vtefc gfrkr nn".lower()

code2 = "Wejmvse - Fbtkqal zqb rso rnl cwihsf".lower()
m2 = "Ufgoqcbje".lower()

code3 = "Pieagnm - Jkoijeg nbw zwx mle grwsnn".lower()
m3 = "Mya qutf de buj otv rms dy srd vkdof".lower()

l = []

#for ch in lowers:
#    if ch not in normal_txt:
#        l.append(ch)

d1 = {}
d2 = {}
d3 = {}

for i in range(len(normal_txt)):
    d1[code1[i]] = normal_txt[i]
    d2[code2[i]] = normal_txt[i]
    d3[code3[i]] = normal_txt[i]

str_new = ""
for ch in code1:
    str_new += d1[ch]

print (d1)


thats suck!


