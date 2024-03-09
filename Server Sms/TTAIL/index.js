let serialportgsm = require("serialport-gsm");
const express = require("express");

const app = express();
app.use(express.json());
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

app.get("/sendSMS/:id/:message", (req, res) => {
  let smsSentCount = 0;

  const { id, message } = req.params;
  const decodedMessage = decodeURIComponent(message.replace(/\+/g, ' ').replace(/\\n/g, '\n'));
  console.log(id, decodedMessage);
  // res.status(200).json({ id: decodedMessage });
  modem.sendSMS(id, decodedMessage, false, (data) => {
    smsSentCount++;
    console.log(data);
    if (smsSentCount === 2) {
      res.status(200).json({ id: data.data.response });
    }
  });
});

app.listen(3000, () => {
  console.log("Server running on port 3000");
  modem.open("COM6", options, {});
  modem.on("open", (data) => {
    modem.initializeModem((data) => {
      console.log("modem is initialized");
    });
  });
});
