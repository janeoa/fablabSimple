#include <SPI.h>
#include <MFRC522.h>
#include <Ethernet.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>


LiquidCrystal_I2C lcd(0x27,16,2);


byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xEF };
char server[] = "rfid.nudl.kz";
 char rfid[] = "00000000";

const byte successLED = 2;
const byte errorLED    = 3;

#define RST_PIN         9          // Configurable, see typical pin layout above
#define SS_1_PIN        8         // Configurable, take a unused pin, only HIGH/LOW required, must be diffrent to SS 2
#define NR_OF_READERS   1

byte ssPins[] = {SS_1_PIN};

MFRC522 mfrc522[NR_OF_READERS];   // Create MFRC522 instance.
IPAddress ip(192, 168, 0, 177);
IPAddress myDns(192, 168, 0, 1);

EthernetClient client;
String data;

unsigned long beginMicros, endMicros;
unsigned long byteCount = 0;
bool printWebData = true;

void setup() {

  lcd.init();
  lcd.backlight();
  lcd.setCursor(3,0);
  lcd.print("Smesh&Creat");
  
  pinMode(errorLED, OUTPUT);
  pinMode(successLED, OUTPUT);

  Serial.begin(9600); // Initialize serial communications with the PC
  while (!Serial);    // Do nothing if no serial port is opened (added for Arduinos based on ATMEGA32U4)

  SPI.begin();        // Init SPI bus

  for (uint8_t reader = 0; reader < NR_OF_READERS; reader++) {
    mfrc522[reader].PCD_Init(ssPins[reader], RST_PIN); // Init each MFRC522 card
    Serial.print(F("Reader "));
    Serial.print(reader);
    Serial.print(F(": "));
    mfrc522[reader].PCD_DumpVersionToSerial();
  }

  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // Check for Ethernet hardware present
    if (Ethernet.hardwareStatus() == EthernetNoHardware) {
      Serial.println("Ethernet shield was not found.  Sorry, can't run without hardware. :(");
      while (true) {
        delay(1); // do nothing, no point running without Ethernet hardware
      }
    }
    if (Ethernet.linkStatus() == LinkOFF) {
      Serial.println("Ethernet cable is not connected.");
    }
    // try to congifure using IP address instead of DHCP:
    Ethernet.begin(mac, ip, myDns);
  } else {
    Serial.print("  DHCP assigned IP ");
    Serial.println(Ethernet.localIP());
  }
}


void loop() {

  int len = client.available();
  if (len > 0) {
    byte buffer[80];
    if (len > 80) len = 80;
    client.read(buffer, len);
    if (printWebData) {
      //Serial.println("####>");
      //Serial.write(buffer, len); // show in the serial monitor (slows some boards)
      if(strstr(buffer, "[\"Success\"]")>0){
        Serial.println("?????????");  
        digitalWrite(successLED, HIGH);
        digitalWrite(errorLED, LOW);
        tone(A0, 3000);
        delay(200);
        noTone(A0);
        delay(2000);
      }
      //Serial.println("<####");
    }
    byteCount = byteCount + len;
  }

  digitalWrite(successLED, LOW);
  digitalWrite(errorLED, LOW);
  
  for (uint8_t reader = 0; reader < NR_OF_READERS; reader++) {
    if (mfrc522[reader].PICC_IsNewCardPresent() && mfrc522[reader].PICC_ReadCardSerial()) {
      tone(A0, 2000);
      delay(200);
      noTone(A0);
//      digitalWrite(successLED, HIGH);
      digitalWrite(errorLED, HIGH);
      dump_byte_array(mfrc522[reader].uid.uidByte, mfrc522[reader].uid.size);
      sendPOST(rfid);
      lcd.clear();
      lcd.setCursor(3,0);
      lcd.print("Smesh&Creat");
      lcd.setCursor(2,1);
      lcd.print(rfid);
      
      mfrc522[reader].PICC_HaltA();
      mfrc522[reader].PCD_StopCrypto1();
      
    }
  }
}

void dump_byte_array(byte *buffer, byte bufferSize) {
//  for (byte i = 0; i < bufferSize; i++) {
sprintf(rfid ,"rfid=%02X%02X%02X%02X", buffer[0], buffer[1], buffer[2], buffer[3]);
Serial.println(rfid);
    
//  }
}


void sendPOST(String post){

//  delay(1000);
  Serial.print("connecting to ");
  Serial.print(server);
  Serial.println("...");

  data = post;
  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.print("connected to ");
    Serial.println(client.remoteIP());
    // Make a HTTP request:
    client.println("POST /enter HTTP/1.1");
    client.println("Host: rfid.nudl.kz");
    client.println("Cache-Control : no-cache");
    client.println("Pragma: no-cache");
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.print("Content-Length: ");
    client.println(data.length());
    client.println();
    client.print(data);
    client.println();
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  beginMicros = micros();

  
}
