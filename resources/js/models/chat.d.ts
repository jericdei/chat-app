type Chat = {
    id: number;
    user_1: number;
    user_2: number;
    created_at: string /* Date */ | null;
    updated_at: string /* Date */ | null;
    messages?: Message[] | null;
    receiver?: User | null;
    latest_message?: Message | null;
};
