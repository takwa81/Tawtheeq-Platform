import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";

const app = express();
const httpServer = createServer(app);
// should add something from flutter
const io = new Server(httpServer, {
    cors: { origin: "*" },
});

app.use(express.json());

app.post("/message", (req, res) => {
    const { chatId, senderId, message, sentAt } = req.body;

    io.to(chatId).emit("newMessage", { chatId, senderId, message, sentAt });

    res.sendStatus(200);
});

io.on("connection", (socket) => {
    console.log("User connected:", socket.id);

    socket.on("joinChat", (chatId) => {
        socket.join(chatId);
        console.log(`User joined chat room: ${chatId}`);
    });

    socket.on("sendMessage", (data) => {
        io.to(data.chatId).emit("newMessage", data);
    });

    socket.on("disconnect", () => {
        console.log("User disconnected:", socket.id);
    });
});

httpServer.listen(3000, () => {
    console.log("Socket.IO server running on port 3000");
});
