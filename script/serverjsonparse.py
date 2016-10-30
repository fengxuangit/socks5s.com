#!/usr/bin/env python
# coding=utf-8

import sys
import os
import json
import commands
from datetime import datetime
from optparse import OptionParser

rootjsonfile = '/tmp/shadowsocks3.json'
ssbakpath = '/tmp/bak/'


def shell_exec(cmd):
    return commands.getstatusoutput(cmd)


def restartss():
    (status, output) = shell_exec("ssserver -d stop")
    if status == 0 and output.find("stopped") >=0 :
        print "restart shadow ok!"
        return True
    return False


def bakssfile():
    with open(rootjsonfile, 'rb') as f:
        source = f.read()
    backfile = "{0}/{1}.json".format(ssbakpath, datetime.now().strftime("%Y%m%d-%H-%M"))
    with open(backfile, 'wb') as f:
        f.write(source)
    return True


def updatejson(path):
    if os.path.exists("{0}/_SUCCESS".format(path)) == False:
        return "No upload complete or no update file"
    fp1 = open(rootjsonfile, 'rb')
    rootssjson = json.load(fp1).copy()
    fp1.close()
    # import ipdb;ipdb.set_trace()
    for dirpath, dirnames, filenames in os.walk(path):
        for files in filenames:
            if files.startswith('update') == False:
                continue
            fp2 = open(path + files, 'rb')
            resource = json.load(fp2)
            fp2.close()
            for key in resource:
                rootssjson['port_password'][key] = resource[key]
            os.unlink(path + files)
    if bakssfile() == True:
        with open(rootjsonfile, 'wb') as fp1:
            fp1.write(json.dumps(rootssjson, indent=4))
    restartss()
    print "update ok!"


def generatejson(path):
    if os.path.exists("{0}/_SUCCESS".format(path)) == False:
        return "No upload complete or no generate file"
    fp1 = open(rootjsonfile, 'rb')
    rootssjson = json.load(fp1).copy()
    fp1.close()
    for dirpath, dirnames, filenames in os.walk(path):
        for files in filenames:
            if files.startswith('pass') == False:
                continue
            fp2 = open(path + files, 'rb')
            resource = json.load(fp2).copy()
            rootssjson['port_password'].update(resource)
            fp2.close()
            os.unlink(path + files)
    if bakssfile() == True:
        with open(rootjsonfile, 'wb') as fp1:
            fp1.write(json.dumps(rootssjson, indent=4))
    restartss()
    print "update done!"


def usage():
    parser = OptionParser()
    parser.add_option("-p", "--path", type="string", dest="path", help="json path to parse", default="/home/fengxuan/upjson")
    if len(sys.argv) < 2:
        parser.print_help()
        sys.exit()
    global options
    (options, args) = parser.parse_args()


def main():
    # path = "/tmp/upjson/"
    usage()
    path = options.path
    print generatejson(path)
    print updatejson(path)
    os.unlink("{0}/_SUCCESS".format(path))


if __name__ == '__main__':
    main()
