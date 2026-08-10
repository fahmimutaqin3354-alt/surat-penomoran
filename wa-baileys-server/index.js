const { default: makeWASocket, useMultiFileAuthState, DisconnectReason } = require('@whiskeysockets/baileys');
const { Boom } = require('@hapi/boom');
const qrcode = require('qrcode-terminal');
const express = require('express');
const fs = require('fs');

const app = express();
app.use(express.json());

let sock;

async function startSock() {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info');

    sock = makeWASocket({
        auth: state,
        printQRInTerminal: false,
    });

    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (qr) {
            qrcode.generate(qr, { small: true });
        }

        if (connection === 'close') {
            const shouldReconnect = new Boom(lastDisconnect?.error)?.output?.statusCode !== DisconnectReason.loggedOut;
            console.log('Koneksi terputus, reconnect:', shouldReconnect);
            if (shouldReconnect) startSock();
        } else if (connection === 'open') {
            console.log('WhatsApp berhasil terhubung!');
        }
    });

    sock.ev.on('creds.update', saveCreds);
}

startSock();

app.post('/send-file', async (req, res) => {
    const { nomor, pesan, filePath, fileName } = req.body;

    try {
        const fileBuffer = fs.readFileSync(filePath);

        await sock.sendMessage(nomor + '@s.whatsapp.net', {
            document: fileBuffer,
            fileName: fileName || 'surat.pdf',
            mimetype: 'application/pdf',
            caption: pesan,
        });

        res.json({ success: true, message: 'Pesan berhasil dikirim' });
    } catch (err) {
        console.error(err);
        res.status(500).json({ success: false, error: err.message });
    }
});

app.listen(3000, () => console.log('Server API jalan di http://localhost:3000'));