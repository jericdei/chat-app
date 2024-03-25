type Message = {
    id: number;
    chat_id: number;
    from: number;
    value: string;
    created_at: string /* Date */ | null;
    updated_at: string /* Date */ | null;
    sender?: User | null;
};
