import React, { createContext, useContext, useState } from "react";

const UserContext = createContext();

export const useUserContext = () => useContext(UserContext);

export const UserProvider = ({ children }) => {
    const [users, setUsers] = useState([]);

    const fetchUsers = async () => {
        try {
            const res = await fetch("/api/users");
            const data = await res.json()
            console.log(res)
            console.log(data)
            //setUsers(data?.users||[]);
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
            const data = await res.json();
            setUsers([...users, data]);
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
