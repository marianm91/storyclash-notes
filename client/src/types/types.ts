export interface User {
    readonly id: number;
    name: string;
    avatar: string;
}

export interface Note {
    readonly id: number;
    user: User;
    content: string;
    createdAt: string;
    replies: Reply[];
}

export interface Reply {
    readonly id: number;
    user: User;
    content: string;
    createdAt: string;
    parentNote: Note;
}