import React, { createContext, useContext, useState } from "react";

const UserContext = createContext();

export const useUserContext = () => useContext(UserContext);

export const UserProvider = ({ children }) => {
    const [users, setUsers] = useState([]);

    const fetchUsers = async () => {
        try {
            console.log("Fetching users...");
            const res = await fetch("/api/users");
            const data = await res.json()
            console.log("Users:", data.users);
            setUsers(data?.users);
        } catch (error) {
            console.error(error);
        }
    };

    const createUser = async (user) => {
        try {
            const res = await fetch("/api/users", {
                method: "POST",
                body: JSON.stringify(user),
                headers: {
                    "Content-Type": "application/json",
                },
            });
            await res.json();
            await fetchUsers();
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <UserContext.Provider value={{ users, fetchUsers, createUser }}>
            {children}
        </UserContext.Provider>
    );
};
