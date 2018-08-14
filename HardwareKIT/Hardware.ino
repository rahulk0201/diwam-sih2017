/*
  The circuit:
  lcd 1,5,16 ->GND
  lcd 2,15, -> 5v
  LCD 3 -> 2.7KOhm to gnd
  lcd 7,8,9,10 -> none
 * LCD 4 RS pin to digital pin 11
 * LCD 6 Enable pin to digital pin 10
 * LCD D4 pin to digital pin 9
 * LCD D5 pin to digital pin 8
 * LCD D6 pin to digital pin 7
 * LCD D7 pin to digital pin 6
 * LCD R/W pin to ground
 * LCD VSS pin to ground
 * LCD VCC pin to 5V
 * 10K resistor:
 * ends to +5V and ground
 * //wiper to LCD VO pin (pin 3)
 * LCD Pin 3 to GND //works 2k7 resistor for 16*2
 * For 20*4 Pin 3 to GND
*/

// include the library code:
#include <SoftwareSerial.h>
#include "GravityTDS.h"

//SoftwareSerial mySerial(9, 10); //RX, Tx
//Connect Tx of GSM Module to pin 9 and RX to 10;
SoftwareSerial mySerial(2, 3); //Tx, Rx

String cc = "+91";
String cnum = "7021472648";
String messagetoSend = "DiWAM Update. Kit Started.";
unsigned long previousMillis;
const unsigned long interval = 60000;           // interval at which to send (milliseconds)
//60000-> 1min
int count=0;
#include <LiquidCrystal.h>
#include <OneWire.h> 
#include <EEPROM.h>

//pH
#define SensorPin 1          //pH meter Analog output to Arduino Analog Input 1
#define RED 14         //operating instructions
#define YEL 15
#define GRE 16

unsigned long int Runs=0;

unsigned long int avgValue;  //Store the average value of the sensor feedback
float b;
int buf[10],temp;

const int buzzer = 17;

//Temp
int DS18S20_Pin = 5; //DS18S20 Signal pin on digital 2
//Temperature chip i/o
OneWire ds(DS18S20_Pin);  // on digital pin 4
float getTemp();

// initialize the library by associating any needed LCD interface pin
// with the arduino pin number it is connected to
const int rs = 6, en = 7, d4 = 8, d5 = 9, d6 = 10, d7 = 11;

 int sensorValue;
 float voltage, turb;


//TDS
#define TdsSensorPin A4
GravityTDS gravityTds;

float tdsValue = 0;

 
 
//ORP
#define VOLTAGE 5.00    //system voltage
#define OFFSET 0        //zero drift voltage
         //operating instructions

double orpValue;

#define ArrayLenth  40    //times of collection
#define orpPin 2          //orp meter output,connect to Arduino controller ADC pin

int orpArray[ArrayLenth];
int orpArrayIndex=0;

double avergearray(int* arr, int number){
  int i;
  int max,min;
  double avg;
  long amount=0;
  if(number<=0){
    printf("Error number for the array to avraging!/n");
    return 0;
  }
  if(number<5){   //less than 5, calculated directly statistics
    for(i=0;i<number;i++){
      amount+=arr[i];
    }
    avg = amount/number;
    return avg;
  }else{
    if(arr[0]<arr[1]){
      min = arr[0];max=arr[1];
    }
    else{
      min=arr[1];max=arr[0];
    }
    for(i=2;i<number;i++){
      if(arr[i]<min){
        amount+=min;        //arr<min
        min=arr[i];
      }else {
        if(arr[i]>max){
          amount+=max;    //arr>max
          max=arr[i];
        }else{
          amount+=arr[i]; //min<=arr<=max
        }
      }//if
    }//for
    avg = (double)amount/(number-2);
  }//if
  return avg;
}
 
//EC
#define EEPROM_write(address, p) {int i = 0; byte *pp = (byte*)&(p);for(; i < sizeof(p); i++) EEPROM.write(address+i, pp[i]);}
#define EEPROM_read(address, p)  {int i = 0; byte *pp = (byte*)&(p);for(; i < sizeof(p); i++) pp[i]=EEPROM.read(address+i);}

#define ReceivedBufferLength 20
char receivedBuffer[ReceivedBufferLength+1];   // store the serial command
byte receivedBufferIndex = 0;

#define ecSensorPin  A3  //EC Meter analog output,pin on analog 1

#define SCOUNT  100           // sum of sample point
int analogBuffer[SCOUNT];    //store the analog value read from ADC
int analogBufferIndex = 0;

#define compensationFactorAddress 8    //the address of the factor stored in the EEPROM
float compensationFactor;

#define VREF 5000  //for arduino uno, the ADC reference is the power(AVCC), that is 5000mV

boolean enterCalibrationFlag = 0;
float temperature,ECvalue,ECvalueRaw;

//LCD
LiquidCrystal lcd(rs, en, d4, d5, d6, d7);

void setup() {


  pinMode(RED,OUTPUT);
  pinMode(GRE,OUTPUT);
  pinMode(YEL,OUTPUT);
 
  pinMode(buzzer, OUTPUT);
  tone(buzzer, 2000);
  delay(1000); 
  noTone(buzzer);

  digitalWrite(RED, HIGH);
  digitalWrite(GRE, HIGH);
  digitalWrite(YEL, HIGH);
  delay(2000);
  digitalWrite(RED, LOW);
  digitalWrite(GRE, LOW);
  digitalWrite(YEL, LOW);

  //TDS
  gravityTds.setPin(TdsSensorPin);
  gravityTds.setAref(5.0);  //reference voltage on ADC, default 5.0V on Arduino UNO
  gravityTds.setAdcRange(1024);  //1024 for 10bit ADC;4096 for 12bit ADC
  gravityTds.begin();  //initialization

  

  Serial.begin(9600);  
  // set up the LCD's number of columns and rows:
  lcd.begin(20, 4);
  // Print a message to the LCD.
  lcd.print("Hello, DiWAM ->SIH:)");
  readCharacteristicValues(); //read the compensationFactor

     mySerial.begin(9600);
     lcd.setCursor(1,1);
     lcd.print("Initializing..");

     delay(1000);
     makeCall();
     //delay(30000);
     SendMessage() ;
     // delay(30000);
  
}

void loop() {
  // set the cursor to column 0, line 1
  // (note: line 1 is the second row, since counting begins with 0):
  Runs++;
  unsigned long currentMillis = millis();


  //ORP
  static unsigned long orpTimer=millis();   //analog sampling interval
  static unsigned long printTime=millis();


  //pH
  for(int i=0;i<10;i++)       //Get 10 sample value from the sensor for smooth the value
  { 
    buf[i]=analogRead(SensorPin);
    delay(10);
  }
  for(int i=0;i<9;i++)        //sort the analog from small to large
  {
    for(int j=i+1;j<10;j++)
    {
      if(buf[i]>buf[j])
      {
        temp=buf[i];
        buf[i]=buf[j];
        buf[j]=temp;
      }
    }
  }
  avgValue=0;
  for(int i=2;i<8;i++)                      //take the average value of 6 center sample
    avgValue+=buf[i];
  float phValue=(float)avgValue*5.0/1024/6; //convert the analog into millivolt
  phValue=3.5*phValue;                      //convert the millivolt into pH value
  
  

  /*Turb*/
  sensorValue = analogRead(A0);// read the input on analog pin 0:
  voltage = sensorValue * (5.0 / 1024.0); // Convert the analog reading (which goes from 0 - 1023) to a voltage (0 - 5V):
  turb = -1120.4*voltage*voltage + 5742.3*voltage - 4352.9;
  // print out the value you read:

  //Temp
  temperature = getTemp(); //will take about 750ms to run
  
  //TDS
  gravityTds.setTemperature(temperature);  // set the temperature and execute temperature compensation
  gravityTds.update();  //sample and calculate 
  tdsValue = gravityTds.getTdsValue();  // then get the value
  
  
  //EC
  if(serialDataAvailable() > 0)
  {
      byte modeIndex = uartParse();
      ecCalibration(modeIndex);    // If the correct calibration command is received, the calibration function should be called.
  }

   static unsigned long analogSampleTimepoint = millis();
   if(millis()-analogSampleTimepoint > 30U) //every 30ms,read the analog value from the ADC
   {
     analogSampleTimepoint = millis();
     analogBuffer[analogBufferIndex] = analogRead(ecSensorPin);    //read the analog value and store into the buffer,every 40ms
     analogBufferIndex++;
     if(analogBufferIndex == SCOUNT) 
         analogBufferIndex = 0;
   }
   
   static unsigned long tempSampleTimepoint = millis();
   if(millis()-tempSampleTimepoint > 850U)  // every 1.7s, read the temperature from DS18B20
   {
      tempSampleTimepoint=millis();
      temperature = getTemp();  // read the current temperature from the  DS18B20
   }
   
   static unsigned long printTimepoint = millis();
   if(millis()-printTimepoint > 1000U)
   {
      printTimepoint = millis();
      float AnalogAverage = getMedianNum(analogBuffer,SCOUNT);   // read the stable value by the median filtering algorithm
      float averageVoltage=AnalogAverage*(float)VREF/1024.0;
      if(temperature == -1000)
      {
          temperature = 25.0;      //when no temperature sensor ,temperature should be 25^C default
         // Serial.print(temperature,1); 
        //Serial.print(F("^C(default)    EC:"));
      }else{
         // Serial.print(temperature,1);    //current temperature
         // Serial.print(F("^C             EC:"));
      }
     float TempCoefficient=1.0+0.0185*(temperature-25.0);    //temperature compensation formula: fFinalResult(25^C) = fFinalResult(current)/(1.0+0.0185*(fTP-25.0));
     float CoefficientVolatge=(float)averageVoltage/TempCoefficient;   
     if(CoefficientVolatge<150)Serial.println(F(" No solution!"));   //25^C 1413us/cm<-->about 216mv  if the voltage(compensate)<150,that is <1ms/cm,out of the range
     else if(CoefficientVolatge>3300)Serial.println(F("Out of the range!"));  //>20ms/cm,out of the range
     else{ 
      if(CoefficientVolatge<=448)ECvalue=6.84*CoefficientVolatge-64.32;   //1ms/cm<EC<=3ms/cm
      else if(CoefficientVolatge<=1457)ECvalue=6.98*CoefficientVolatge-127;  //3ms/cm<EC<=10ms/cm
      else ECvalue=5.3*CoefficientVolatge+2278;                           //10ms/cm<EC<20ms/cm
      ECvalueRaw = ECvalue/1000.0;
      ECvalue = ECvalue/compensationFactor/1000.0;    //after compensation,convert us/cm to ms/cm
      /*Serial.print(ECvalue,2);     //two decimal
      Serial.print(F("ms/cm"));
      */ 
      if(enterCalibrationFlag)             // in calibration mode, print the voltage to user, to watch the stability of voltage
       {  
          //Serial.print(F("            Factor:"));
          //Serial.print(compensationFactor);   
       }
    // Serial.println();
     }          
   }

   //ORP
   if(millis() >= orpTimer)
  {
    orpTimer=millis()+20;
    orpArray[orpArrayIndex++]=analogRead(orpPin);    //read an analog value every 20ms
    if (orpArrayIndex==ArrayLenth) {
      orpArrayIndex=0;
    }   
    orpValue=((30*(double)VOLTAGE*1000)-(75*avergearray(orpArray, ArrayLenth)*VOLTAGE*1000/1024))/75-OFFSET;   //convert the analog value to orp according the circuit
  }
  
  if(millis() >= printTime)   //Every 800 milliseconds, print a numerical, convert the state of the LED indicator
  {
  printTime=millis()+800;
  
      
  }
  if(Runs >=1)
  { 
  //delay(1000);
  Serial.print("\nORP: ");
  Serial.print((int)orpValue);
  Serial.println(" mV");
  
  Serial.print("pH: ");
  Serial.println(phValue,2);

  Serial.print("Turbidity: ");
  Serial.println(turb);
  
  Serial.print("Temperature: ");
  Serial.println(temperature);
  
  Serial.print("EC: ");
  Serial.print(ECvalue,2);     //two decimal
  Serial.println(F(" ms/cm"));

  Serial.print(tdsValue,0);
  Serial.println("ppm");
  
  //messagetoSend = "DiWAM Readings\n";  
  lcd.begin(20, 4);
  // Print a message to the LCD.
  lcd.setCursor(0, 0);
  lcd.print("----Kit Readings----");
  
  lcd.setCursor(0, 1);
  lcd.print("pH   :");
  lcd.print(phValue,2);

  messagetoSend ="1,";
  
  messagetoSend +=String(phValue)+",";
  
  lcd.setCursor(0, 2);
  lcd.print("Temp :");
  lcd.print((int)temperature);
  lcd.print(" C");
  messagetoSend +=String(temperature)+",";
  
  lcd.setCursor(0, 3);
  lcd.print("Tur  :");
  lcd.print(turb);
  lcd.print(" NTU");
  messagetoSend +=String(turb)+",";

  delay(4000);
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("----Kit Readings----");
    
  lcd.setCursor(0, 1);  
  lcd.print("EC   :");
  lcd.print(ECvalue,2);
  lcd.print(" mS/cm");
  messagetoSend +=String(ECvalue)+",";
      
  lcd.setCursor(0, 2);
  lcd.print("ORP  :");
  orpValue = orpValue/1000;
  lcd.print(orpValue);
  lcd.print("V");
  messagetoSend +=String(orpValue)+",";
 
  lcd.setCursor(0, 3);
  lcd.print("TDS  :");
  lcd.print(tdsValue);
  lcd.print("ppm");
  messagetoSend +=String(tdsValue);
  
  }
  
  if (currentMillis - previousMillis >= interval || count==0) {
    // save the last time you blinked the LED
    count=1;
    previousMillis = currentMillis;
    SendMessage() ;
    delay(30000);

  }
}


float getTemp(){
  //returns the temperature from one DS18S20 in DEG Celsius
  byte data[12];
  byte addr[8];
  if ( !ds.search(addr)) {
      //no more sensors on chain, reset search
      ds.reset_search();
      return -1000;
  }
  if ( OneWire::crc8( addr, 7) != addr[7]) {
    //  Serial.println("CRC is not valid!");
      return -1000;
  }
  if ( addr[0] != 0x10 && addr[0] != 0x28) {
      Serial.print("Device is not recognized");
      return -1000;
  }
  ds.reset();
  ds.select(addr);
  ds.write(0x44,1); // start conversion, with parasite power on at the end
  delay(750); // Wait for temperature conversion to complete
  byte present = ds.reset();
  ds.select(addr);    
  ds.write(0xBE); // Read Scratchpad
  for (int i = 0; i < 9; i++) { // we need 9 bytes
    data[i] = ds.read();
  }
  ds.reset_search();
  byte MSB = data[1];
  byte LSB = data[0];
  float tempRead = ((MSB << 8) | LSB); //using two's compliment
  float TemperatureSum = tempRead / 16;
  return TemperatureSum;
}

boolean serialDataAvailable(void)
{
  char receivedChar;
  static unsigned long receivedTimeOut = millis();
  while (Serial.available()>0) 
  {   
    if (millis() - receivedTimeOut > 500U) 
    {
      receivedBufferIndex = 0;
      memset(receivedBuffer,0,(ReceivedBufferLength+1));
    }
    receivedTimeOut = millis();
    receivedChar = Serial.read();
    if (receivedChar == '\n' || receivedBufferIndex==ReceivedBufferLength){
    receivedBufferIndex = 0;
    strupr(receivedBuffer);
    return true;
    }else{
      receivedBuffer[receivedBufferIndex] = receivedChar;
      receivedBufferIndex++;
    }
  }
  return false;
}

byte uartParse()
{
  byte modeIndex = 0;
  if(strstr(receivedBuffer, "CALIBRATION") != NULL) 
      modeIndex = 1;
  else if(strstr(receivedBuffer, "EXIT") != NULL) 
      modeIndex = 3;
  else if(strstr(receivedBuffer, "CONFIRM") != NULL)   
      modeIndex = 2;
  return modeIndex;
}

void ecCalibration(byte mode)
{
    char *receivedBufferPtr;
    static boolean ecCalibrationFinish = 0;
    float factorTemp;
    switch(mode)
    {
      case 0:
      if(enterCalibrationFlag)
         Serial.println(F("Command Error"));
      break;
      
      case 1:
      enterCalibrationFlag = 1;
      ecCalibrationFinish = 0;
      Serial.println();
      Serial.println(F(">>>Enter Calibration Mode<<<"));
      Serial.println(F(">>>Please put the probe into the 12.88ms/cm buffer solution<<<"));
      Serial.println();
      break;
     
     case 2:
      if(enterCalibrationFlag)
      {
          factorTemp = ECvalueRaw / 12.88;
          if((factorTemp>0.85) && (factorTemp<1.15))
          {
              Serial.println();
              Serial.println(F(">>>Confrim Successful<<<"));
              Serial.println();
              compensationFactor =  factorTemp;
              ecCalibrationFinish = 1;
          }
          else{
            Serial.println();
            Serial.println(F(">>>Confirm Failed,Try Again<<<"));
            Serial.println();
            ecCalibrationFinish = 0;
          }        
      }
      break;

        case 3:
        if(enterCalibrationFlag)
        {
            Serial.println();
            if(ecCalibrationFinish)
            {
               EEPROM_write(compensationFactorAddress, compensationFactor);
               Serial.print(F(">>>Calibration Successful"));
            }
            else Serial.print(F(">>>Calibration Failed"));       
            Serial.println(F(",Exit Calibration Mode<<<"));
            Serial.println();
            ecCalibrationFinish = 0;
            enterCalibrationFlag = 0;
        }
        break;
    }
}

int getMedianNum(int bArray[], int iFilterLen) 
{
      int bTab[iFilterLen];
      for (byte i = 0; i<iFilterLen; i++)
      {
    bTab[i] = bArray[i];
      }
      int i, j, bTemp;
      for (j = 0; j < iFilterLen - 1; j++) 
      {
    for (i = 0; i < iFilterLen - j - 1; i++) 
          {
      if (bTab[i] > bTab[i + 1]) 
            {
    bTemp = bTab[i];
          bTab[i] = bTab[i + 1];
    bTab[i + 1] = bTemp;
       }
    }
      }
      if ((iFilterLen & 1) > 0)
  bTemp = bTab[(iFilterLen - 1) / 2];
      else
  bTemp = (bTab[iFilterLen / 2] + bTab[iFilterLen / 2 - 1]) / 2;
      return bTemp;
}

void readCharacteristicValues()
{
    EEPROM_read(compensationFactorAddress, compensationFactor);  
    if(EEPROM.read(compensationFactorAddress)==0xFF && EEPROM.read(compensationFactorAddress+1)==0xFF && EEPROM.read(compensationFactorAddress+2)==0xFF && EEPROM.read(compensationFactorAddress+3)==0xFF)
    {
      compensationFactor = 1.0;   // If the EEPROM is new, the compensationFactorAddress is 1.0(default).
      EEPROM_write(compensationFactorAddress, compensationFactor);
    }
}

void makeCall() {
  Serial.flush();
  String cmd = "ATD";
  String terminate = ";";
  String callCmd = cmd + cnum + terminate;
  mySerial.println(callCmd); // ATDxxxxxxxxxx; -- watch out here for semicolon at the end!!
  Serial.println(callCmd);
  delay(10000);
  mySerial.println("ATH;");
}
void SendMessage() {
  mySerial.println("AT+CMGF=1");    //Sets the GSM Module in Text Mode
  delay(1000);  // Delay of 1000 milli secValueonds or 1 secValueond
  String myContact = "AT+CMGS=\"";
  String ending = "\"\r";
  String details = myContact + cc + cnum + ending;
  mySerial.println(details); // Replace x with mobile number
  delay(1000);
  //mySerial.println(mesg);// The SMS text you want to send
  mySerial.print(messagetoSend);
  delay(100);
  Serial.println(details);
  Serial.print(messagetoSend);
  mySerial.println((char)26);// ASCII code of CTRL+Z
  delay(1000);
}
void RecieveMessage() {
  Serial.println("AT+CNMI=2,2,0,0,0");
  mySerial.println("AT+CNMI=2,2,0,0,0"); // AT Command to recValueieve a live SMS
  delay(1000);
}
