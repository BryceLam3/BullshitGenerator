#!/usr/bin/python3
import os, re, sys
import random, json

文章长度限制 = 6000
段落长度范围 = [100, 300]
重复度 = 1

with open("data.json", mode='r', encoding="utf-8") as file:
    data = json.loads(file.read())

名人名言 = data["famous"] # a 代表前面垫话，b代表后面垫话
前面垫话 = data["before"] # 在名人名言前面弄点废话
后面垫话 = data['after']  # 在名人名言后面弄点废话
废话 = data['bosh'] # 代表文章主要废话来源

def 洗牌遍历(列表):
    global 重复度
    池 = list(列表) * 重复度
    while True:
        random.shuffle(池)
        for 元素 in 池:
            yield 元素
            
下一句废话 = 洗牌遍历(废话)
下一句名人名言 = 洗牌遍历(名人名言)

def 来点名人名言():
    global 下一句名人名言
    xx = next(下一句名人名言)
    xx = xx.replace(  "a",random.choice(前面垫话) )
    xx = xx.replace(  "b",random.choice(后面垫话) )
    return xx

def 另起一段():
    xx = "</p>\n<p>"
    return xx

if len(sys.argv) <= 1:
    exit(1);

tmp = "<p>"
段落长度 = 0
while len(tmp) < 文章长度限制 or 段落长度 < 段落长度范围[0] or not tmp.endswith("。"):
    if 段落长度 > 段落长度范围[1]: #防止段落过长
        分支 = 0
    elif 段落长度 < 段落长度范围[0]: #防止段落过短
        分支 = random.randint(5,100)
    else:
        分支 = random.randint(0,100)
    if 分支 < 5 and tmp.endswith("。"):
        tmp += 另起一段()
        段落长度 = 0
    elif 分支 < 20:
        content = 来点名人名言()
        tmp += content
        段落长度 += len(content)
    else:
        content = next(下一句废话)
        tmp += content
        段落长度 += len(content)
tmp += "\n</p>"
tmp = tmp.replace("x",sys.argv[1])
print(tmp)
