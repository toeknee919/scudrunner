#!/usr/bin/env python
import urllib2
import StringIO
import gzip
import sys
import os

def main(argv):
	baseURL = "http://aviationweather.gov/adds/dataserver_current/current/"
	metfilename = "tafs.cache.csv.gz"
	d,f = os.path.split(os.path.abspath(__file__))
	outFilePath = d + "/" + metfilename[:-3]

	response = urllib2.urlopen(baseURL + metfilename)
	compressedFile = StringIO.StringIO(response.read())
	decompressedFile = gzip.GzipFile(fileobj=compressedFile)

	with open(outFilePath, 'w') as outfile:
	    outfile.write(decompressedFile.read())
	outfile.close()
	return "Taf update complete"

if __name__ == "__main__":
   ret = main(sys.argv[1:])
   print ret
