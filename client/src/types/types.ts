export interface User {
    id: number;
    name: string;
    avatar: string;
}

export interface Note {
    id: number;
    user: User;
    content: string;
    createdAt: string;
    replies?: Reply[];
}

export interface Reply extends Note {
    id: number;
    user: User;
    content: string;
    createdAt: string;
    parentNote: Note;
}