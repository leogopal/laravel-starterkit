import os
import sys
import time

start_time = time.time()

RED   = "\033[1;31m"
GREEN = "\033[0;32m"
ENDCOLOR = "\033[0;0m"

def removeQuotesFromValue(value):
	value = value.replace("'", '"')
	# value = value.replace('"', "")
	return value

def splitLineIntoParts(line):
	line = line.lstrip()
	line = line.rstrip()
	line = removeQuotesFromValue(line)
	line = line.split("=", 1)
	return line

def setConfigVar(name, value):
	os.system('heroku config:set ' + name + '=' + value + '--app laravel-starterkit')

with open('.env') as e:
	numCurrentVar = 0

	sys.stdout.write(GREEN)
	print("\n*** Starting... ***")
	sys.stdout.write(ENDCOLOR)

	for line in e:
		l = splitLineIntoParts(line)

		if (len(l) > 1):
			name = l[0]
			value = l[1]
			numCurrentVar += 1

			sys.stdout.write(GREEN)
			print ("\n*** Setting: %s to %s ***" % (name, value))
			sys.stdout.write(ENDCOLOR)

			setConfigVar(name, value)

	e.close()

elapsed = time.time() - start_time
sys.stdout.write(GREEN)
print("\n*** Complete! %d variables set in %ds! ***" % (numCurrentVar, elapsed))
