import RPi.GPIO as GPIO
import time
import sys

millimeters = sys.argv[1]

#Calculating the number of seconds

seconds = float(millimeters) / 30

#Starting the pump and letting out the water

GPIO.setmode(GPIO.BCM)

RELAIS_1_GPIO = 20
GPIO.setup(RELAIS_1_GPIO, GPIO.OUT)
GPIO.output(RELAIS_1_GPIO, GPIO.LOW)
print("[+] The pump will be running for {} seconds...".format(seconds))
time.sleep(seconds)
GPIO.output(RELAIS_1_GPIO, GPIO.HIGH)
print("[-] the pump has been shutdown.")
#Closing the GPIO cleanly
GPIO.cleanup()  