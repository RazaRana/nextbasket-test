import {Avatar, ListItem, ListItemAvatar, ListItemText} from "@mui/material";
import React from 'react';

function UserListItem({ user }) {
    return (
        <ListItem alignItems="flex-start">
            <ListItemAvatar>
                <Avatar>{user.firstName.charAt(0)}</Avatar>
            </ListItemAvatar>
            <ListItemText
                primary={`${user.firstName} ${user.lastName}`}
                secondary={user.email}
            />
        </ListItem>
    );
}

export default UserListItem;
