import React from 'react';
import {List } from '@mui/material';
import UserListItem from "@/components/Users/UserListItem";

function UserList({ users }) {
    console.log(users)
    return (
        <List>
            {users?.map((user) => (
                <UserListItem key={user.id} user={user} />
            ))}
        </List>
    );
}

export default UserList;

