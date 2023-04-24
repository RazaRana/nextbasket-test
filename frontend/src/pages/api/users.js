import axios from "axios";

const api = axios.create({
    baseURL: process.env.API_BASE_URL,
    headers: {
        "Content-Type": "application/json",
    },
});

export default async function handler(req, res) {
    switch (req.method) {
        case "GET": {
            try {
                const response = await api.get("/users");
                const data = response.data;
                res.status(200).json(data);
            } catch (error) {
                res.status(500).json({ message: "Failed to fetch users" });
            }
            break;
        }
        case "POST": {
            try {
                const newUser = req.body;
                const response = await api.post("/users", newUser);
                const createdUser = response.data;
                res.status(201).json(createdUser);
            } catch (error) {
                console.error(error);
                res.status(500).json({ message: "Failed to create user" });
            }
            break;
        }
        default:
            res.setHeader("Allow", ["GET", "POST"]);
            res.status(405).end(`Method ${req.method} Not Allowed`);
    }
}
