require('dotenv').config();
const AssistantV1 = require('watson-developer-cloud/assistant/v1');
const express = require('express');
const bodyParser = require('body-parser');

const app = express();

app.use(bodyParser.json());
app.use(express.static('./public'));

const port = 3000;

const assistant = new AssistantV1({
  iam_apikey: 'GylnwpLvNdaJUQ11WTQH4i73ydr5NRzDXUDP9oPnbxlf',//put your apikey here
 //iam_apikey: 'DsU-ngFKTXV_ras2FfjcoctsjNeQjgUJExuUSNK6Ly4u',
  //iam_apikey: process.env.ASSISTANT_IAM_APIKEY,
  //password: process.env.ASSISTANT_PASSWORD,
  url: 'https://gateway-lon.watsonplatform.net/assistant/api',// update the link of the chatbot here
  version: '2019-04-29',// look for the date of the version of your chatbot in the site
});

app.post('/conversation/', (req, res) => {
  const { text, context = {} } = req.body;

  const params = {
    input: { text },
    workspace_id: 'f2b45b77-e5ca-4d0f-b0e4-4ce5a7bde0a3',//Put your workspace id here
   //workspace_id: process.env.WORKSPACE_ID, 
    context,
  };

  assistant.message(params, (err, response) => {
    if (err) {
      console.error(err);
      res.status(500).json(err);
    } else {
      res.json(response);
    }
  });
});

app.listen(port, () => console.log(`Running on port ${port}`));
