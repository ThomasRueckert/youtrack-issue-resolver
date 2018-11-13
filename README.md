This is a small script for marking youtrack issues as fixed by a given filter.

run:

    bash run.sh '#sandbox -resolved'
    bash run.sh '-resolved #uapi "mongo.error"'
    bash run.sh '-resolved #uapi "error: GenServer #PID"'
