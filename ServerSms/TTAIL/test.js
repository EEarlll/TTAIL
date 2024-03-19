let serialportgsm = require("serialport-gsm");
let modem = serialportgsm.Modem();

let options = {
  baudRate: 115200,
  dataBits: 8,
  stopBits: 1,
  parity: "none",
  rtscts: false,
  xon: false,
  xoff: false,
  xany: false,
  autoDeleteOnReceive: true,
  enableConcatenation: true,
  incomingCallIndication: true,
  incomingSMSIndication: true,
  pin: "",
  customInitCommand: "",
  cnmiCommand: "AT+CNMI=2,1,0,2,1",
  logger: console,
};

modem.open("COM6", options, {});

modem.on("open", (data) => {
  modem.initializeModem((data) => {
    console.log("modem is initialized");

    // modem.sendSMS("639656836880", 'test', false, (data) => {
    //   console.log(data);
    // });
    modem.getOwnNumber((result, err) => {
      if (err) {
        console.log(`Error retrieving own Number - ${err}`);
      } else {
        console.log(`Own number: ${JSON.stringify(result)}`);
      }
    });

    modem.getNetworkSignal((result, err) => {
      if (err) {
        console.log(`Error retrieving Signal Strength - ${err}`);
      } else {
        console.log(`Signal Strength: ${JSON.stringify(result)}`);
      }
    });

    modem.checkModem((result, err) => {
      if (err) {
        console.log(`error: ${err}`);
      } else {
        console.log(`Check modem: ${JSON.stringify(result)}`);
      }
    });
  });
});

modem.on('onSendingMessage', result =>{
    console.log(result);
})