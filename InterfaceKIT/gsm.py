from __future__ import print_function

import requests
import serial.tools.list_ports, serial



def find_port():
	"""This function finds the address of the USB port

	This function is responsible for finding the address
	of the USB port responsible for communicating serially
	with the connected Arduino
	"""
	ports = list(serial.tools.list_ports.comports())
	for p in ports:
		our_port = str(p).split(" ")[0]
	return our_port


def main():
	"""This is the main function responsible for dealing
	with and controlling the entire GSM backup mechanism.

	This function is responsible for finding out the port
	that the Arduino is connected on and then using serial
	communication to parse the sensor data received via SMS
	and then sending that data via a HTTP POST request.
	"""
	diwam_url = "http://diwam.000webhostapp.com/DIWAM/feed_data.php?" 
	our_port_address = find_port()
	serialport = serial.Serial(our_port_address, baudrate=9600, timeout=1)
	while 1:
		raw_serial_data = serialport.readline().decode().replace("\n","")    
		raw_serial_data = raw_serial_data.replace(" ","").replace("\r","")
		if raw_serial_data == "":
			pass
		else:
			if "+CMT:" in raw_serial_data:
				pass
			else:
				message_data = raw_serial_data.split(",")
				kit_id = message_data[0]
				ph = message_data[1]
				temperature = message_data[2]
				turbidity = message_data[3]
				ec = message_data[4]
				orp = message_data[5]
				tds = message_data[6]
				post_url = diwam_url + "kit_id=" + kit_id + "&ph=" + ph + \
							"&ec=" + ec + "&tds=" + tds + "&orp=" + orp + \
							"&temperature=" + temperature + "&turbidity=" + \
							turbidity
				r = requests.post(post_url)


if __name__=="__main__":
	main()