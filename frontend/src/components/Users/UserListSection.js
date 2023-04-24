import {useEffect, useState} from 'react';
import { Box, Button, Typography } from '@mui/material';
import { makeStyles } from '@material-ui/core/styles';
import UserList from './UserList';
import NewUserModal from './NewUserModal';
import {useUserContext} from "@/components/Context/UserContext";
import {useCreateUserModel} from "@/components/Users/hooks";

const useStyles = makeStyles((theme) => ({
    header: {
        marginTop: theme.spacing(4),
        marginBottom: theme.spacing(4),
        textAlign: 'center',
    },
    addUserButton: {
        marginTop: theme.spacing(2),
        marginBottom: theme.spacing(2),
    },
}));

function UserListSection() {
    const classes = useStyles();

    const { users, fetchUsers } = useUserContext();
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            await fetchUsers();
            setLoading(false);
        };
        fetchData();
    }, []);

    const {
        handleOpenModal,
        handleCloseModal,
        isModalOpen
    } = useCreateUserModel()

    return (
        <Box>
            <Typography variant="h4" component="h1" className={classes.header}>
                User List
            </Typography>
            <Button
                variant="contained"
                color="primary"
                onClick={handleOpenModal}
                className={classes.addUserButton}
            >
                Add User
            </Button>
            {loading ? (
                <Typography>Loading...</Typography>
            ) : (
                <UserList users={users} />
            )}
            <NewUserModal isOpen={isModalOpen} handleClose={handleCloseModal} />
        </Box>
    );
}


export default UserListSection;
